function closePromoBanner() {
  const banner = document.querySelector('.promo-banner');
  const countdownElement = document.querySelector('.banner-countdown');
  
  if (banner) {
    banner.style.display = 'none';
    
    let expiryDate = new Date();
    if (countdownElement && countdownElement.dataset.end) {
      expiryDate = new Date(countdownElement.dataset.end);
    } else {
      expiryDate.setDate(expiryDate.getDate() + 1);
    }
    
    // Set cookie with expiry date
    document.cookie = `promo_closed=1; path=/; expires=${expiryDate.toUTCString()}`;
  }
}

// Check cookie on load
document.addEventListener('DOMContentLoaded', function () {
  if (document.cookie.includes('promo_closed=1')) {
    const banner = document.querySelector('.promo-banner');
    if (banner) banner.style.display = 'none';
  }



  const countdownElement = document.querySelector('.banner-countdown')

  if (countdownElement && countdownElement.dataset.end) {
    let endDate = new Date(countdownElement.dataset.end)
    const now = new Date()
  
    const isSameDay =
      endDate.getFullYear() === now.getFullYear() &&
      endDate.getMonth() === now.getMonth() &&
      endDate.getDate() === now.getDate()
  
    if (isSameDay) {
      endDate.setHours(23, 59, 59, 999)
    }
  
    const updateCountdown = () => {
      const currentTime = new Date().getTime()
      const distance = endDate.getTime() - currentTime
  
      if (distance < 0) {
        countdownElement.innerHTML = `
          <div style="display: flex; gap: 10px; justify-content: center;">
            <div style="text-align: center"><div>00</div><small>days</small></div>
            <div style="text-align: center"><div>00</div><small>hours</small></div>
            <div style="text-align: center"><div>00</div><small>minutes</small></div>
            <div style="text-align: center"><div>00</div><small>seconds</small></div>
          </div>`
        return
      }
  
      const days = Math.floor(distance / (1000 * 60 * 60 * 24))
      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))
      const seconds = Math.floor((distance % (1000 * 60)) / 1000)
  
      countdownElement.innerHTML = `
        <div style="display: flex; gap: 10px; justify-content: center;">
          <div style="text-align: center"><div>${String(days).padStart(2, '0')}</div><small>days</small></div>
          <div style="text-align: center"><div>${String(hours).padStart(2, '0')}</div><small>hours</small></div>
          <div style="text-align: center"><div>${String(minutes).padStart(2, '0')}</div><small>minutes</small></div>
          <div style="text-align: center"><div>${String(seconds).padStart(2, '0')}</div><small>seconds</small></div>
        </div>`
    }
  
    updateCountdown()
    setInterval(updateCountdown, 1000)
  }
  
});
